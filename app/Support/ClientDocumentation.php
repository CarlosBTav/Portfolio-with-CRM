<?php

namespace App\Support;

use App\Models\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ClientDocumentation
{
    public static function linkedSlugs(Client $client): Collection
    {
        $clientName = Str::lower(trim($client->commercial_name));

        return collect(config('documentation.versions', []))
            ->map(function (array $documentation, string $slug) {
                return [
                    'slug' => $slug,
                    'client_name' => $documentation['client_name'] ?? null,
                    'commercial_name_aliases' => $documentation['commercial_name_aliases'] ?? [],
                ];
            })
            ->filter(function (array $documentation) use ($client, $clientName) {
                $documentationClientName = Str::lower(trim((string) ($documentation['client_name'] ?? '')));
                $nameMatches = $documentationClientName !== '' && $documentationClientName === $clientName;

                $aliases = collect($documentation['commercial_name_aliases'] ?? [])
                    ->merge([$documentation['client_name'] ?? ''])
                    ->filter()
                    ->map(fn ($alias) => Str::lower(trim((string) $alias)))
                    ->filter()
                    ->unique();
                $aliasMatches = $aliases->contains(fn (string $alias) => $alias === $clientName);

                $clientSlug = Str::slug($client->commercial_name);
                $docSlug = $documentation['slug'];
                $slugMatches = $docSlug === $clientSlug
                    || Str::endsWith($clientSlug, '-'.$docSlug);

                $explicitSlug = (string) ($client->documentation_slug ?? '');
                $explicitMatch = $explicitSlug !== '' && $explicitSlug === $docSlug;

                return $nameMatches || $aliasMatches || $slugMatches || $explicitMatch;
            })
            ->pluck('slug')
            ->values();
    }
}
