<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users'         => User::count(),
            'events'        => Event::count(),
            'registrations' => Registration::count(),
            'categories'    => Category::count(),
        ];

        $latestEvents = Event::with('organizer', 'category')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latestEvents'));
    }

    public function categories()
    {
        $categories = Category::withCount('events')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100|unique:categories',
            'description' => 'nullable|string',
        ]);

        Category::create($data);

        return back()->with('success', 'Categoría creada.');
    }

    public function destroyCategory(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Categoría eliminada.');
    }

    public function users()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,organizer,attendee',
        ]);

        $user->update(['role' => $request->role]);

        return back()->with('success', 'Rol actualizado.');
    }

    public function events()
    {
        $events = Event::with('organizer', 'category')->latest()->paginate(15);
        return view('admin.events.index', compact('events'));
    }

    public function toggleEvent(Event $event)
    {
        $event->update(['active' => !$event->active]);
        return back()->with('success', 'Estado del evento actualizado.');
    }
}
