<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $members = [
            [
                'name' => 'Jean-Marie Kabila',
                'role' => 'Directeur Général',
                'bio' => 'Supervise la stratégie et le développement des activités de JMC Services S.P.R.L.',
                'email' => 'direction@jmc-services.cd',
                'phone' => null,
                'social_links' => [
                    ['name' => 'LinkedIn', 'url' => 'https://www.linkedin.com/'],
                ],
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Aline Mbala',
                'role' => 'Responsable des opérations',
                'bio' => 'Coordonne la planification et le suivi des projets sur le terrain.',
                'email' => null,
                'phone' => null,
                'social_links' => [
                    ['name' => 'LinkedIn', 'url' => 'https://www.linkedin.com/'],
                    ['name' => 'X', 'url' => 'https://x.com/'],
                ],
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Patrick Lunda',
                'role' => 'Ingénieur travaux',
                'bio' => 'Assure la qualité technique et le respect des normes sur les chantiers.',
                'email' => null,
                'phone' => null,
                'social_links' => [],
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($members as $member) {
            TeamMember::query()->updateOrCreate(
                ['name' => $member['name'], 'role' => $member['role']],
                $member,
            );
        }
    }
}
