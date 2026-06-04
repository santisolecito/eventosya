<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name'     => 'Admin Sistema',
            'email'    => 'admin@eventosya.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'phone'    => '3001234567',
        ]);

        $organizer = User::create([
            'name'     => 'Carlos Organizador',
            'email'    => 'organizer@eventosya.com',
            'password' => Hash::make('password'),
            'role'     => 'organizer',
            'phone'    => '3109876543',
        ]);

        $attendee = User::create([
            'name'     => 'María Asistente',
            'email'    => 'attendee@eventosya.com',
            'password' => Hash::make('password'),
            'role'     => 'attendee',
            'phone'    => '3156667788',
        ]);

        $cat1 = Category::create(['name' => 'Conciertos',   'description' => 'Eventos musicales en vivo']);
        $cat2 = Category::create(['name' => 'Conferencias', 'description' => 'Charlas y ponencias académicas']);
        $cat3 = Category::create(['name' => 'Talleres',     'description' => 'Talleres prácticos y workshops']);
        $cat4 = Category::create(['name' => 'Deportes',     'description' => 'Competencias y torneos deportivos']);

        $event1 = Event::create([
            'organizer_id' => $organizer->id,
            'category_id'  => $cat2->id,
            'title'        => 'Laravel Summit Colombia 2025',
            'description'  => 'El evento más grande de Laravel en Colombia.',
            'venue'        => 'Centro de Convenciones Plaza Mayor',
            'city'         => 'Medellín',
            'event_date'   => now()->addMonths(2)->toDateString(),
            'event_time'   => '09:00:00',
            'active'       => true,
        ]);

        $event2 = Event::create([
            'organizer_id' => $organizer->id,
            'category_id'  => $cat1->id,
            'title'        => 'Noche de Rock en el Parque',
            'description'  => 'Festival de bandas locales con música en vivo.',
            'venue'        => 'Parque de los Deseos',
            'city'         => 'Medellín',
            'event_date'   => now()->addMonth()->toDateString(),
            'event_time'   => '19:00:00',
            'active'       => true,
        ]);

        $event3 = Event::create([
            'organizer_id' => $organizer->id,
            'category_id'  => $cat3->id,
            'title'        => 'Taller de Fotografía Digital',
            'description'  => 'Aprende técnicas de fotografía con cámaras digitales.',
            'venue'        => 'IUE Campus Envigado',
            'city'         => 'Envigado',
            'event_date'   => now()->addWeeks(3)->toDateString(),
            'event_time'   => '14:00:00',
            'active'       => true,
        ]);

        Ticket::create(['event_id' => $event1->id, 'name' => 'General',    'price' => 50000,  'total_qty' => 200]);
        Ticket::create(['event_id' => $event1->id, 'name' => 'VIP',        'price' => 150000, 'total_qty' => 50]);
        Ticket::create(['event_id' => $event1->id, 'name' => 'Estudiante', 'price' => 25000,  'total_qty' => 100]);
        Ticket::create(['event_id' => $event2->id, 'name' => 'General',    'price' => 30000,  'total_qty' => 500]);
        Ticket::create(['event_id' => $event2->id, 'name' => 'VIP',        'price' => 80000,  'total_qty' => 30]);
        Ticket::create(['event_id' => $event3->id, 'name' => 'General',    'price' => 0,      'total_qty' => 20]);
        Ticket::create(['event_id' => $event3->id, 'name' => 'Estudiante', 'price' => 0,      'total_qty' => 30]);
    }
}
