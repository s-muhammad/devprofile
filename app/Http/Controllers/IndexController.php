<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comments;
use App\Models\Projects;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->take(3)->get();
        $featured = Projects::where('is_featured', 1)->first();
        $query = Projects::latest()->take(3);
        if ($featured) {
            $query->where('id', '!=', $featured->id);
        }
        $otherProjects = $query->get();
        $projects = collect([$featured])->filter()->concat($otherProjects)->take(3);
        return view('welcome', compact('projects', 'blogs'));
    }

    public function blog()
    {
        $perPage = 6;
        $blogs = Blog::latest()->paginate($perPage);
        $header = Blog::whereBetween('id', [1, 4])->inRandomOrder()->first();
        $total = Blog::count();
        return view('blog.index', compact('blogs', 'header', 'total', 'perPage'));
    }

    public function blogLoadMore(Request $request)
    {
        $perPage = 6;
        $page = $request->input('page', 2);
        $blogs = Blog::latest()->paginate($perPage, ['*'], 'page', $page);
        $total = Blog::count();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('blog.partials.card', ['blogs' => $blogs])->render(),
                'hasMore' => $blogs->hasMorePages(),
                'nextPage' => $page + 1,
            ]);
        }

        return redirect()->route('blog.loadMore');
    }

    public function blogSingle(Blog $blog)
    {
        $captcha = $this->generateMathCaptcha();
        session([
            'comment_captcha_answer' => $captcha['answer'],
            'comment_captcha_question' => $captcha['question']
        ]);
        $comments = $blog->comments()->where('approved', 1)->get();
        return view('blog.single',[
            'blog' => $blog,
            'comments' => $comments,
            'captcha' => $captcha['question']
        ]);
    }

    public function storeComment(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'comment' => 'required|string|min:3|max:1000',
            'blog_id' => 'required|exists:blogs,id',
            'captcha_answer' => 'required|numeric'
        ]);

        $captchaAnswer = session('comment_captcha_answer');
        $userAnswer = (int) $request->input('captcha_answer');

        if ($userAnswer !== $captchaAnswer) {
            return back()
                ->withErrors(['captcha_answer' => 'پاسخ کپچا نادرست است!'])
                ->withInput();
        }

        Comments::create([
            'name' => $request->name,
            'comment' => $request->comment,
            'blog_id' => $request->blog_id,
        ]);

        // پاک کردن کپچا
        session()->forget(['comment_captcha_answer', 'comment_captcha_question']);

        return back()->with('success', 'دیدگاه شما با موفقیت ثبت شد!');
    }

    private function generateMathCaptcha()
    {
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);

        $operators = ['+', '-', '*'];
        $operator = $operators[array_rand($operators)];

        switch ($operator) {
            case '+':
                $answer = $num1 + $num2;
                break;
            case '-':
                $answer = $num1 - $num2;
                break;
            case '*':
                $answer = $num1 * $num2;
                break;
            default:
                $answer = $num1 + $num2;
        }

        return [
            'question' => "$num1 $operator $num2 = ?",
            'answer' => $answer
        ];
    }
}
