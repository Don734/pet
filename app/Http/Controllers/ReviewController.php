<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Review;
use App\Models\Service;
use App\Models\Handbook;
use App\Models\User;
use Laravel\Nova\Notifications\NovaNotification;
use Laravel\Nova\Nova;
use Laravel\Nova\URL;

class ReviewController extends Controller
{
    protected function sendNotification($message, $link)
    {
        $admins = User::all();
        $notification = NovaNotification::make()->icon('bell')->type('info')
            ->message($this->user->name.$message);

        if ($link) {
            $notification->action('Модерация', URL::remote($link));
        }

        foreach ($admins as $admin) {
            $admin->notify($notification);
        }
    }

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = auth('users')->user();

            return $next($request);
        });
    }

    public function store(StoreReviewRequest $request)
    {
        $reviewableType = $request->input('reviewable_type');
        $reviewableId = $request->input('reviewable_id');

        $validReviewableModels = [Handbook::class, Service::class];
        if (!in_array($reviewableType, $validReviewableModels)) {
            return redirect()->back()->withErrors('Неправильная модель.');
        }

        $review = Review::create([
            'reviewable_type' => $reviewableType,
            'reviewable_id' => $reviewableId,
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
            'name' => $this->user->name,
            'client_id' => $this->user->id
        ]);

        $this->sendNotification(
            ' добавил комментарий',
            Nova::path().'/resources/reviews/'.$review->id
        );

        return redirect()->back()->with('success', 'Отзыв успешно добавлен и появится после модерации!');
    }
}
