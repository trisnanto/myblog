<?php

use App\Http\Controllers\PostDashboardController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('home', ['title' => 'Home']);
});

// Route::get('/authors/{user:username}', function (User $user) {
//     // $posts = $user->posts->load(['author', 'category']);

//     return view('posts', ['title' => count($user->posts) . ' Article by ' . $user->name, 'posts' => $user->posts]);
// });

// Route::get('/category/{category:slug}', function (Category $category) {
//     // $posts = $category->posts->load(['author', 'category']);
//     return view('posts', ['title' => 'Category : ' . $category->name, 'posts' => $category->posts]);
// });

Route::get('/posts', function () {
    // $posts = Post::with(['author', 'category'])->latest()->get();
    $posts = Post::latest()->filter(request(['keywords','category','author']))->paginate(9)->withQueryString();

    return view('posts', ['title' => 'Blog', 'posts' => $posts]);
});

Route::get('/posts/{post:slug}', function (Post $post) {
    return view('post', ['title' => 'Post Details', 'post' => $post]);
});

Route::get('/contact', function () {
    return view('contact', ['title' => 'Contact']);
});

Route::get('/about', function () {
    return view('about', ['title' => 'About']);
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::resource('dashboard', PostDashboardController::class)->middleware(['auth', 'verified']);



Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [PostDashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard', [PostDashboardController::class, 'store'])->name('dashboard.store');
    Route::get('/dashboard/create', [PostDashboardController::class, 'create'])->name('dashboard.create');
    Route::get('/dashboard/{post:slug}', [PostDashboardController::class, 'show'])->name('dashboard.show');
    Route::get('/dashboard/{post:slug}/edit', [PostDashboardController::class, 'edit'])->name('dashboard.edit');
    Route::patch('/dashboard/{post:slug}', [PostDashboardController::class, 'update'])->name('dashboard.update');
    Route::delete('/dashboard/{post:slug}', [PostDashboardController::class, 'destroy'])->name('dashboard.destroy');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/upload', [ProfileController::class, 'upload'])->name('profile.upload');
});

require __DIR__.'/auth.php';
