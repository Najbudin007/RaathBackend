<?php

// config/menu.php

return [
    'navigation' => [
        [
            'title' => 'Dashboard',
            'icon' => 'ri-dashboard-2-fill',
            'url' => 'admin.home',
        ],
        [
            'title' => 'Users',
            'icon' => 'ri-user-line',
            'url' => 'admin.users.index',
        ],
        [
            'title' => 'Categories',
            'icon' => 'ri-folder-line',
            'url' => 'admin.categories.index',
        ],
        [
            'title' => 'Products',
            'icon' => 'ri-shopping-bag-line',
            'url' => 'admin.products.index',
        ],
        [
            'title' => 'Projects',
            'icon' => 'ri-building-line',
            'url' => 'admin.projects.index',
        ],
        [
            'title' => 'Yatras',
            'icon' => 'ri-map-2-line',
            'url' => 'admin.yatras.index',
        ],
        [
            'title' => 'Gallery',
            'icon' => 'ri-image-2-line',
            'url' => 'admin.gallery.index',
        ],
        [
            'title' => 'Team Members',
            'icon' => 'ri-team-line',
            'url' => 'admin.team.index',
        ],
        [
            'title' => 'Membership Plans',
            'icon' => 'ri-vip-crown-line',
            'url' => 'admin.memberships.index',
        ],
        [
            'title' => 'Pages',
            'icon' => 'ri-file-text-line',
            'url' => 'admin.cms-pages.index',
        ],
        [
            'title' => 'Subscribers',
            'icon' => 'ri-mail-line',
            'url' => 'admin.subscribers.index',
        ],
        [
            'title' => 'Donations',
            'icon' => 'ri-hand-heart-line',
            'url' => 'admin.donations.index',
        ],
        [
            'title' => 'Sponsorship Tiers',
            'icon' => 'ri-award-line',
            'url' => 'admin.sponsorship-tiers.index',
        ],
        [
            'title' => 'Budget Breakdowns',
            'icon' => 'ri-pie-chart-line',
            'url' => 'admin.budget-breakdowns.index',
        ],
        [
            'title' => 'Documents',
            'icon' => 'ri-file-list-line',
            'url' => 'admin.documents.index',
        ],
        [
            'title' => 'Orders',
            'icon' => 'ri-shopping-cart-line',
            'url' => 'admin.orders.index',
        ],
        [
            'title' => 'Google Anlytics',
            'icon' => 'bi bi-bar-chart-line',
            'url' => 'admin.google-analytics',
        ],

        [
            'title' => 'Subscription',
            'icon' => 'ri-folder-user-line',
            'url' => 'admin.subscription',
        ],


        [
            'title' => 'Careers',
            'icon' => 'ri-information-line',
            'submenu' => [
                [
                    'title' => 'Job Role',
                    'url' => 'admin.job_roles.index',
                ],
                [
                    'title' => 'Career',
                    'url' => 'admin.careers.index',
                ],
            ],
        ],
        [
            'title' => 'Blogs',
            'icon' => 'ri-chat-settings-line',
            'submenu' => [
                [
                    'title' => 'Blogs List',
                    'url' => 'admin.blogs.index',
                ],
                [
                    'title' => 'Categories',
                    'url' => 'admin.blog_categories.index',
                ],
                [
                    'title' => 'Tags',
                    'url' => 'admin.tags.index',
                ],
            ],
        ],
        // department
        [
            'title' => 'Departments',
            'icon' => 'ri-building-4-line',
            'url' => 'admin.departments.index',
        ],
        [
            'title' => 'Portfolio',
            'icon' => 'ri-chat-poll-line',
            'submenu' => [
                [
                    'title' => 'Categories',
                    'url' => 'admin.portfolio_categories.index',
                ],
                [
                    'title' => 'Portfolio List',
                    'url' => 'admin.portfolios.index',
                ],

            ],
        ],
    ],

    'Settings' => [
        [
            'title' => 'Site Settings',
            'icon' => 'ri-settings-line',
            'url' => 'admin.settings.index',
        ],
        [
            'title' => 'Service Category',
            'icon' => 'ri-settings-4-line',
            'url' => 'admin.service_categories.index',
        ],
        [
            'title' => 'Blog Category',
            'icon' => ' ri-list-settings-line',
            'url' => 'admin.blog_categories.index',
        ],
        [
            'title' => 'Portfolio Category',
            'icon' => 'ri-list-settings-line',
            'url' => 'admin.portfolio_categories.index',
        ],
        [
            'title' => 'Tags',
            'icon' => 'ri-price-tag-3-fill',
            'url' => 'admin.tags.index',
        ],
    ],
    'Home Page' => [
        [
            'title' => 'Home Slider',
            'icon' => 'ri-image-line',
            'url' => 'admin.banners.index',
        ],
        [
            'title' => 'Metrics',
            'icon' => 'ri-file-chart-fill',
            'url' => 'admin.metrics.index',
        ],
        [
            'title' => 'Teams',
            'icon' => ' ri-team-line',
            'url' => 'admin.teams.index',
        ],
        [
            'title' => 'Services',
            'icon' => 'ri-global-fill',
            'url' => 'admin.services.index',
        ],
        [
            'title' => 'Clients',
            'icon' => 'ri-team-fill',
            'url' => 'admin.clients.index',
        ],
    ],

    'Shila Prabhupada' => [

        [
            'title' => 'Books',
            'icon' => 'ri-book-2-fill',
            'url' => 'admin.books.index',
        ],

        [
            'title' => 'Temples',
            'icon' => 'ri-building-2-fill',
            'url' => 'admin.temples.index',
        ],
    ],

    'Medias' => [
        [
            'title' => 'Gallery',
            'icon' => 'ri-image-fill',
            'url' => 'admin.medias.index',
        ],
    ],
];
