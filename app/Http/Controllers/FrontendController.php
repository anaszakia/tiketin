<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home(Request $request)
    {
        $categories = EventCategory::orderBy('name')->get();
        $query = Event::with(['category', 'organizer', 'tickets'])
            ->where('status', 'published')
            ->orderByRaw('start_date IS NULL, start_date ASC');

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($categoryQuery) => $categoryQuery->where('slug', $request->category));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($eventQuery) use ($search) {
                $eventQuery->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('venue_name', 'like', "%{$search}%");
            });
        }

        $events = $query->paginate(9)->withQueryString();
        $featuredEvent = $events->first();

        return view('frontend.home', compact('events', 'categories', 'featuredEvent'));
    }

    public function show(string $slug)
    {
        $event = Event::with(['category', 'organizer', 'tickets'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $relatedEvents = Event::with(['category', 'tickets'])
            ->where('status', 'published')
            ->whereKeyNot($event->id)
            ->when($event->category_id, fn ($query) => $query->where('category_id', $event->category_id))
            ->latest()
            ->take(3)
            ->get();

        return view('frontend.events.show', compact('event', 'relatedEvents'));
    }

    public function checkout(string $slug)
    {
        $event = Event::with(['category', 'organizer', 'tickets' => fn ($query) => $query->where('status', 'active')])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('frontend.checkout', compact('event'));
    }
}
