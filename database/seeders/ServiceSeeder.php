<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Catalogue officiel des services JMC.
     *
     * L'ordre de la liste correspond à l'ordre d'affichage de la page
     * « /services ». Les services mis en avant sur l'accueil sont
     * signalés par « featured » avec leur ordre d'accueil dédié.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function catalogue(): array
    {
        return [
            [
                'slug' => 'construction-generale',
                'title' => 'Construction générale',
                'description' => 'Réalisation de bâtiments résidentiels, commerciaux et industriels. Nous prenons en charge la coordination du projet, de la préparation à la livraison.',
                'icon' => 'building2',
                'deliverables' => [
                    'Bâtiments résidentiels et villas',
                    'Immeubles commerciaux et bureaux',
                    'Complexes industriels et entrepôts',
                    'Établissements publics (écoles, hôpitaux)',
                    'Rénovation et extension de bâtiments',
                ],
                'benefits' => [
                    'Approche clé en main',
                    'Suivi du projet',
                    'Coordination des intervenants',
                    'Communication régulière',
                ],
                'is_featured' => true,
                'home_sort_order' => 1,
            ],
            [
                'slug' => 'construction-metallique',
                'title' => 'Construction métallique',
                'description' => 'Fabrication et montage de structures métalliques sur mesure : charpentes, sheds, hangars et ouvrages associés.',
                'icon' => 'hard-hat',
                'deliverables' => [
                    'Charpentes métalliques pour bâtiments',
                    'Sheds, hangars et structures industrielles',
                    'Ponts et passerelles métalliques',
                    'Garde-corps, escaliers et rampes',
                    'Structures pour équipements sportifs',
                ],
                'benefits' => [
                    'Fabrication sur mesure',
                    'Montage sur site',
                    'Coordination avec les autres corps d’état',
                    'Contrôle des assemblages',
                ],
                'is_featured' => true,
                'home_sort_order' => 2,
            ],
            [
                'slug' => 'travaux-publics',
                'title' => 'Travaux publics',
                'description' => 'Réalisation de voiries, réseaux divers, terrassements et aménagements pour les collectivités et le secteur privé.',
                'icon' => 'landmark',
                'deliverables' => [
                    'Voiries et réseaux divers (VRD)',
                    'Routes et pistes rurales',
                    'Aménagements urbains',
                    'Terrassement et nivellement',
                    'Réseaux d’assainissement',
                ],
                'benefits' => [
                    'Coordination des travaux',
                    'Prise en compte de l’environnement du site',
                    'Suivi des étapes',
                    'Communication avec le maître d’ouvrage',
                ],
                'is_featured' => true,
                'home_sort_order' => 4,
            ],
            [
                'slug' => 'electricite-batiment',
                'title' => 'Électricité bâtiment',
                'description' => 'Installations électriques pour bâtiments : conception, réalisation et maintenance des réseaux.',
                'icon' => 'zap',
                'deliverables' => [
                    'Installations électriques intérieures',
                    'Tableaux de distribution et comptage',
                    'Éclairage intérieur et extérieur',
                    'Systèmes de sécurité et alarmes',
                    'Mise aux normes et rénovation',
                ],
                'benefits' => [
                    'Installations adaptées au bâtiment',
                    'Coordination avec les autres lots',
                    'Suivi des essais',
                    'Maintenance et accompagnement',
                ],
                'is_featured' => true,
                'home_sort_order' => 3,
            ],
            [
                'slug' => 'production-de-materiaux',
                'title' => 'Production de matériaux',
                'description' => 'Production et fourniture de matériaux de construction, avec suivi de la qualité et de la disponibilité.',
                'icon' => 'factory',
                'deliverables' => [
                    'Blocs de béton et agglomérés',
                    'Fer à béton et armatures',
                    'Produits métalliques sur mesure',
                    'Mortiers et bétons préparés',
                    'Éléments préfabriqués',
                ],
                'benefits' => [
                    'Suivi de la qualité',
                    'Disponibilité des produits',
                    'Livraison sur chantier',
                    'Conseil technique',
                ],
                'is_featured' => false,
                'home_sort_order' => 0,
            ],
            [
                'slug' => 'fourniture-materiaux-construction',
                'title' => 'Fourniture des matériaux de construction',
                'description' => 'Approvisionnement et livraison de matériaux pour les chantiers et les particuliers : ciment, granulats, fer à béton, bois et fournitures diverses.',
                'icon' => 'package',
                'deliverables' => [
                    'Ciment, sable et granulats',
                    'Fer à béton et armatures',
                    'Bois, planches et coffrages',
                    'Quincaillerie et fournitures de chantier',
                    'Livraison sur chantier',
                ],
                'benefits' => [
                    'Approvisionnement suivi',
                    'Choix des matériaux',
                    'Livraison sur chantier',
                    'Conseil technique',
                ],
                'is_featured' => true,
                'home_sort_order' => 7,
            ],
            [
                'slug' => 'travaux-miniers',
                'title' => 'Travaux miniers',
                'description' => 'Prestations pour le secteur minier : infrastructures de surface, génie civil et aménagements spécifiques.',
                'icon' => 'cog',
                'deliverables' => [
                    'Infrastructures de surface',
                    'Génie civil minier',
                    'Bassins de décantation',
                    'Voiries minières',
                    'Bâtiments industriels miniers',
                ],
                'benefits' => [
                    'Prise en compte des contraintes du site',
                    'Respect des procédures de sécurité',
                    'Coordination des intervenants',
                    'Adaptation au contexte',
                ],
                'is_featured' => false,
                'home_sort_order' => 0,
            ],
            [
                'slug' => 'adduction-eau-potable',
                'title' => 'Adduction d’eau potable',
                'description' => 'Installation de systèmes d’adduction d’eau potable pour les collectivités et les particuliers.',
                'icon' => 'droplets',
                'deliverables' => [
                    'Réseaux de distribution d’eau',
                    'Châteaux d’eau et réservoirs',
                    'Forages et pompages',
                    'Systèmes de traitement',
                    'Raccordements particuliers',
                ],
                'benefits' => [
                    'Solution complète',
                    'Choix des matériaux',
                    'Maintenance préventive',
                    'Accompagnement technique',
                ],
                'is_featured' => false,
                'home_sort_order' => 0,
            ],
            [
                'slug' => 'soudure',
                'title' => 'Soudure',
                'description' => 'Prestations de soudure pour ouvrages métalliques : assemblages, réparation et maintenance.',
                'icon' => 'hammer',
                'deliverables' => [
                    'Soudure de charpentes et structures',
                    'Assemblage de pièces métalliques',
                    'Réparation et maintenance',
                    'Soudure inox et aluminium',
                    'Tuyauterie industrielle',
                ],
                'benefits' => [
                    'Travail en atelier et sur site',
                    'Contrôle des assemblages',
                    'Matériel adapté',
                    'Suivi des travaux',
                ],
                'is_featured' => false,
                'home_sort_order' => 0,
            ],
            [
                'slug' => 'consultance',
                'title' => 'Consultance',
                'description' => 'Services de conseil technique et d’assistance à la maîtrise d’ouvrage pour la planification et la gestion de projets.',
                'icon' => 'globe',
                'deliverables' => [
                    'Études de faisabilité',
                    'Audits techniques',
                    'Assistance à la maîtrise d’ouvrage',
                    'Contrôle technique des constructions',
                    'Expertises et diagnostics',
                ],
                'benefits' => [
                    'Regard technique externe',
                    'Rapports exploitables',
                    'Approche indépendante',
                    'Accompagnement personnalisé',
                ],
                'is_featured' => true,
                'home_sort_order' => 6,
            ],
            [
                'slug' => 'peinture',
                'title' => 'Peinture',
                'description' => 'Travaux de peinture intérieure et extérieure pour bâtiments, avec préparation des supports et finitions.',
                'icon' => 'paintbrush',
                'deliverables' => [
                    'Peinture intérieure et extérieure',
                    'Revêtements muraux décoratifs',
                    'Traitement des façades',
                    'Peinture industrielle (métal)',
                    'Marquage au sol et signalétique',
                ],
                'benefits' => [
                    'Finitions soignées',
                    'Préparation des supports',
                    'Respect du planning',
                    'Propreté du chantier',
                ],
                'is_featured' => false,
                'home_sort_order' => 0,
            ],
            [
                'slug' => 'commerce-de-pieces',
                'title' => 'Commerce de pièces',
                'description' => 'Distribution de pièces détachées et d’équipements pour le bâtiment et la construction métallique.',
                'icon' => 'shopping-cart',
                'deliverables' => [
                    'Quincaillerie et ferronnerie',
                    'Équipements de protection',
                    'Outillage professionnel',
                    'Pièces détachées métalliques',
                    'Accessoires de construction',
                ],
                'benefits' => [
                    'Gamme de produits',
                    'Disponibilité',
                    'Livraison',
                    'Conseil technique',
                ],
                'is_featured' => false,
                'home_sort_order' => 0,
            ],
            [
                'slug' => 'transport-logistique',
                'title' => 'Transport & Logistique',
                'description' => 'Transport de marchandises et de matériaux, organisation des livraisons et appui logistique aux chantiers et aux activités commerciales.',
                'icon' => 'truck',
                'deliverables' => [
                    'Transport de matériaux et marchandises',
                    'Livraison sur chantier',
                    'Manutention et chargement',
                    'Organisation des tournées de livraison',
                    'Appui logistique aux projets',
                ],
                'benefits' => [
                    'Planification des livraisons',
                    'Suivi des expéditions',
                    'Adaptation aux volumes',
                    'Coordination avec les chantiers',
                ],
                'is_featured' => true,
                'home_sort_order' => 8,
            ],
            [
                'slug' => 'agro-pastoral',
                'title' => 'Agro-pastoral',
                'description' => 'Conception et réalisation d’infrastructures agricoles et d’élevage.',
                'icon' => 'sprout',
                'deliverables' => [
                    'Infrastructures agricoles',
                    'Bâtiments d’élevage',
                    'Systèmes d’irrigation',
                    'Stocks et entrepôts agricoles',
                    'Aménagements fonciers',
                ],
                'benefits' => [
                    'Approche intégrée',
                    'Prise en compte de l’environnement',
                    'Durabilité des installations',
                    'Accompagnement technique',
                ],
                'is_featured' => false,
                'home_sort_order' => 0,
            ],
            [
                'slug' => 'boulangerie-patisserie',
                'title' => 'Boulangerie & Pâtisserie',
                'description' => 'Production et vente de pains, viennoiseries et pâtisseries, avec une attention particulière portée à la qualité des ingrédients et à la fraîcheur des produits.',
                'icon' => 'croissant',
                'deliverables' => [
                    'Pains et viennoiseries',
                    'Pâtisseries et gâteaux',
                    'Commandes pour événements',
                    'Produits frais du jour',
                ],
                'benefits' => [
                    'Produits frais',
                    'Qualité des ingrédients',
                    'Commandes personnalisées',
                    'Savoir-faire artisanal',
                ],
                'is_featured' => true,
                'home_sort_order' => 9,
            ],
            [
                'slug' => 'renovation',
                'title' => 'Rénovation',
                'description' => 'Rénovation complète ou partielle de bâtiments existants, extension et amélioration du bâti.',
                'icon' => 'home',
                'deliverables' => [
                    'Rénovation intérieure et extérieure',
                    'Extension de bâtiments existants',
                    'Mise aux normes des installations',
                    'Réhabilitation des façades',
                    'Amélioration du bâti',
                ],
                'benefits' => [
                    'Diagnostic préalable',
                    'Respect du bâti existant',
                    'Finitions soignées',
                    'Suivi du chantier',
                ],
                'is_featured' => true,
                'home_sort_order' => 5,
            ],
        ];
    }

    public function run(): void
    {
        foreach (self::catalogue() as $index => $service) {
            Service::query()->firstOrCreate(
                ['slug' => $service['slug']],
                [
                    'title' => $service['title'],
                    'description' => $service['description'],
                    'icon' => $service['icon'],
                    'deliverables' => $service['deliverables'],
                    'benefits' => $service['benefits'],
                    'is_featured' => $service['is_featured'],
                    'home_sort_order' => $service['home_sort_order'],
                    'is_active' => true,
                    'sort_order' => $index + 1,
                    'image_position' => 'center',
                ],
            );
        }
    }
}
