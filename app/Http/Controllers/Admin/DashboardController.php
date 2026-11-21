<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\TeamMember;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'users' => User::query()->count(),
                'partners' => Partner::query()->count(),
                'active_partners' => Partner::query()->active()->count(),
                'team_members' => TeamMember::query()->count(),
                'active_team_members' => TeamMember::query()->active()->count(),
            ],
        ]);
    }
}
