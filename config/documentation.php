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
        'corazon-de-loba' => [
            'allow_client_notes' => true,
            'title' => 'Corazón de loba',
            'client_name' => 'Corazón de loba',
            'commercial_name_aliases' => [
                'Corazón de loba',
                'Corazon de loba',
            ],
            'related_documentation' => [
                'slug' => 'la-rubia',
                'label' => 'Ver documentación de La rubia',
            ],
            'updated_at' => '2026-06-05',
            'logos' => [],
            'pending_information' => [
                [
                    'html' => 'Confirmar las <span class="font-semibold">secciones principales</span> que debe tener la web. Propuesta inicial: Landing page (Galeria de tattoos, enlaces a redes, llamada a la acción para reservar cita, enlace a secciones, donde encontrarme (Enlace a la web de La Rubia)), Sobre mí, Portfolio/Galería (Con filtro por tipos, incluyendo disponibles), Proceso de reserva, Preguntas frecuentes, Contacto.',
                ],
                'Enviar el texto de presentación para la sección Sobre mí: historia, estilo, experiencia, forma de trabajar y qué queréis transmitir como marca personal.',
                'Enviar logotipo o nombre visual de la marca, si existe, en la mejor calidad disponible. Si no hay logo, confirmar si la web debe trabajar solo con tipografía y estilo visual.',
                'Indicar preferencias de tipografía: elegante, gótica, editorial, minimalista, manuscrita, clásica, agresiva, fina, etc. Si tenéis referencias de letras o marcas, enviarlas.',
                'Indicar colores deseados. Si ya hay paleta de marca, enviar códigos o referencias visuales.',
                'Enviar alguna referencia de webs (También acepto adicionalmente perfiles de Instagram o marcas que os gusten), explicando qué os gusta de cada una: estructura, colores, movimiento, galería, tono, reservas, etc.',
                'Enviar imágenes o vídeos para la cabecera de la web: retrato trabajando, tattoo en proceso, plano corto de tinta, o cualquier material que pueda funcionar como primera impresión.',
                'Enviar una selección de tattoos para la galería, idealmente separados por estilo o categoría. Por ejemplo: fine line, blackwork, ornamental, realismo, lettering, color, cover up, flash, etc.',
                'Confirmar cómo debe funcionar la reserva: WhatsApp, Instagram, formulario web, email u otro sistema. Indicar qué datos debe pedir el formulario.',
                'Enviar información práctica: horario, querías indicar simplemente "Sevilla" como ubicación?, quereís que se pueda cambiar entre español/inglés y otros idiomas? Queréis recibir notificaciones de reservas por email o bot te telegram (También se puede por whatsapp, aunque los bots de whatsapp cobran unos eurillos, aunque es poca cosa)?',
                'Enviar preguntas frecuentes y respuestas. Ejemplos: cómo pedir cita, señal/reserva, precios, diseños personalizados, retoques, cuidados previos, cuidados posteriores, menores de edad, cancelaciones y tiempos de espera.',
                'Enviar instrucciones de cuidados del tatuaje si queréis una sección propia: antes de la cita, primeras horas, curación, productos recomendados y cosas a evitar.',
                'Secundario: Enviar vídeos cortos que podamos usar en la web: proceso, detalles del tattoo terminado, estudio, preparación de materiales, reels verticales o planos horizontales.',
                'Opcional: Enviar imágenes de flashes disponibles, indicando si se pueden repetir, si son piezas únicas, tamaños aproximados y precios orientativos si queréis mostrarlos.',
                'Opcional: Esto es bastante subjetivo pero si os apetece estaría bien que intentarais escribir el tono que quereis que tenga la web: cercano, oscuro, elegante, potente, delicado, espiritual, alternativo, directo, etc... describir lo que os salga',
            ],
            'basic_information' => [],
            'confirmed_information' => [
                [
                    'label' => 'Tipo de proyecto',
                    'value' => 'Web de marca personal para una tatuadora.',
                ],
                [
                    'label' => 'Objetivo inicial',
                    'value' => 'Presentar su trabajo, mostrar portfolio y facilitar solicitudes de cita.',
                ],
            ],
            'notes' => [
                'La web debería apoyarse mucho en fotografía real de tatuajes, retratos y proceso de trabajo.',
                'Cuando haya referencias visuales, se puede definir una dirección más concreta para colores, tipografía y hero.',
            ],
        ],
        'la-rubia' => [
            'allow_client_notes' => true,
            'title' => 'La rubia',
            'client_name' => 'La rubia',
            'commercial_name_aliases' => [
                'La rubia',
            ],
            'related_documentation' => [
                'slug' => 'corazon-de-loba',
                'label' => 'Ver documentación de Corazón de loba',
            ],
            'updated_at' => '2026-06-05',
            'logos' => [],
            'pending_information' => [
                [
                    'html' => 'Confirmar las <span class="font-semibold">secciones principales</span> que debe tener la web. Propuesta inicial: Landing page (imágenes del estudio, tatuadores, imágenes, enlaces a secciones, llamada a acción para reservar,..), Sobre el estudio, Tatuadores, Estilos, Flash, Reservas, Cuidados, Preguntas frecuentes, Ubicación y Contacto.',
                ],
                'Enviar texto corto de presentación de la tienda en la landing page',
                'Enviar logotipos o material de marca en la mejor calidad disponible. Si hay versiones en claro/oscuro, enviarlas también.',
                'Indicar preferencias de tipografía para la marca (Si teneis alguna en concreto comentarla también',
                'Indicar colores corporativos o referencias de color. Si teneis colores que no querais usar específicamente o estilos visuales que no encajen con el estudio.',
                'Enviar alguna referencia de webs de estudios de tattoo, marcas o perfiles que os gusten, explicando qué quereis tomar como referencia: menú, galería, reservas, estilo visual, animaciones, etc.',
                'Enviar imágenes o vídeos para la cabecera y generales del estudio: fachada, recepción, interior del estudio, equipo trabajando, detalles de cabinas, ambiente general o reels del local.',
                'Enviar lista de tatuadores del estudio con nombre artístico, foto, breve bio, estilos que trabaja, Instagram, contacto y lo que veais adicionalmente.',
                'Enviar galería de tattoos por tatuador y, si es posible, clasificadas por estilos. Ejemplos: fine line, blackwork, tradicional, neotradicional, realismo, color, lettering, ornamental, microrealismo, cover up, etc.',
                'Confirmar cómo deben gestionarse las reservas: una reserva general del estudio, contacto directo con cada tatuador, formulario web, WhatsApp, Instagram o combinación de varios canales.',
                'Definir qué campos debe pedir el formulario de reserva. Ejemplos: nombre, teléfono, email, zona del cuerpo, tamaño, idea, referencias, tatuador preferido, presupuesto aproximado y disponibilidad horaria.',
                'Enviar información práctica: dirección, Google Maps, horarios, teléfono, WhatsApp, email, Instagram, TikTok, política de cita previa y si aceptáis walk-ins.',
                'Enviar preguntas frecuentes y respuestas. Ejemplos: señal, cancelaciones, precios mínimos, formas de pago, acompañantes, menores de edad, cover ups, retoques, tiempos de curación y cómo preparar la cita.',
                'Enviar instrucciones de cuidados antes y después del tattoo si queréis una página o bloque propio.',
                'Confirmar si queréis destacar servicios adicionales: piercing, eliminación láser, venta de prints/merch, guest artists, eventos, jornadas flash o cursos.',
                'Esto es algo más abstracto y no es definitivo, pero como referencia está bien intentar definir el tono de la web: rollo underground, estudio premium, oscuro y alternativo, elegante, artístico, moderno, provocador, delicado, etc.',
                'Opcional: Si quereis tener una sección de flashes disponibles, enviar flashes disponibles por tatuador, indicando si son repetibles o piezas únicas, precio/tamaño orientativo y si se quiere mostrar disponibilidad.',
            ],
            'basic_information' => [],
            'confirmed_information' => [
                [
                    'label' => 'Tipo de proyecto',
                    'value' => 'Web para una tienda/estudio de tattoo.',
                ],
                [
                    'label' => 'Objetivo inicial',
                    'value' => 'Presentar el estudio, mostrar tatuadores y trabajos, y facilitar solicitudes de reserva.',
                ],
            ],
            'notes' => [
                'La página debería separar bien la marca del estudio, el equipo de tatuadores y las galerías por artista o estilo.',
                'Conviene decidir pronto si la reserva será centralizada por el estudio o directa con cada tatuador.',
            ],
        ],
    ],
];
