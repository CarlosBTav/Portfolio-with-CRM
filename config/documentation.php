<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Versiones públicas de documentación para clientes
    |--------------------------------------------------------------------------
    |
    | Cada entrada se publica en /documentacion/{slug}
    | Ejemplo: /documentacion/musical-luthier
    |
    */
    'versions' => [
        'musical-luthier' => [
            'allow_client_notes' => true,
            'title' => 'Tienda Musical Luthier',
            'client_name' => 'Musical Luthier',
            // Variantes del nombre en CRM para vincular la doc desde la edición del cliente
            'commercial_name_aliases' => [
                'Tienda Musical Luthier',
            ],
            'domain' => 'MusicalLuthier.com',
            'development_url' => 'https://fabimusica.212.227.94.151.nip.io/',
            'logos' => [
                'large' => [
                    'label' => 'Logo grande',
                    'src' => 'https://fabimusica.212.227.94.151.nip.io/images/logo.png',
                    'href' => 'https://fabimusica.212.227.94.151.nip.io/images/logo.png',
                ],
                'small' => [
                    'label' => 'Logo pequeño (favicon)',
                    'src' => 'https://fabimusica.212.227.94.151.nip.io/favicon-32.png',
                    'href' => 'https://fabimusica.212.227.94.151.nip.io/',
                ],
            ],
            'updated_at' => '2026-05-13',
            'contact_channel' => [
                'label' => 'WhatsApp',
                'value' => 'Responder por WhatsApp',
            ],
            'pending_information' => [
                'Enviar imágenes o vídeos para usar en la landing (especialmente el vídeo que queréis usar en el hero/cabecera).',
                [
                    'html' => 'Texto e imágenes o vídeos para la sección <span class="font-semibold">Sobre nosotros</span> de la web. Podéis ver cómo queda ahora en <a href="https://fabimusica.212.227.94.151.nip.io/sobre-nosotros" target="_blank" rel="noopener noreferrer" class="font-medium text-indigo-600 underline decoration-indigo-300 underline-offset-2 hover:text-indigo-500 dark:text-indigo-300 dark:decoration-indigo-500/60 dark:hover:text-indigo-200">Sobre nosotros</a>.',
                ],
                [
                    'html' => 'Entregarme listado de preguntas y respuestas para la sección de preguntas frecuentes (<a href="https://fabimusica.212.227.94.151.nip.io/preguntas-frecuentes" target="_blank" rel="noopener noreferrer" class="font-medium text-indigo-600 underline decoration-indigo-300 underline-offset-2 hover:text-indigo-500 dark:text-indigo-300 dark:decoration-indigo-500/60 dark:hover:text-indigo-200">Preguntas frecuentes</a>).',
                ],
            ],
            'basic_information' => [
                'instagram' => [
                    'href' => 'https://www.instagram.com/musicalluthier/',
                    'label' => 'MusicalLuthier',
                ],
                'email' => 'musicalluthier@gmail.com',
                'address' => 'C / Hernán Cortés 6, 28220 Majadahonda, Madrid',
            ],
            'confirmed_information' => [
                [
                    'label' => 'Estética base',
                    'value' => 'Tema oscuro con enfoque rockero.',
                ],
                [
                    'label' => 'Catálogo principal',
                    'value' => 'Principalmente guitarras pero también otros instrumentos musicales.',
                ],
                [
                    'label' => 'Colores Corporativos',
                    'value' => 'No hay paleta de colores corporativos definidos. A experimentar.',
                ],
                [
                    'label' => 'Público objetivo',
                    'value' => 'De todas las edades.',
                ],
                [
                    'label' => 'Tipo de público',
                    'value' => 'Media más habitual de edad 25–35 años. Público alternativo; rock, metal y blues.',
                ],
            ],
            'notes' => [
                'Si quieres, puedo proponerte varias opciones visuales para el hero y probarlas contigo.',
                'Esta página se puede seguir ampliando manualmente por código cuando quieras.',
            ],
        ],
    ],
];
