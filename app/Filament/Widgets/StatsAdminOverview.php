<?php

namespace App\Filament\Widgets;

use App\Models\Categorie;
use App\Models\Experience;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsAdminOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            //
            Stat::make("Catégories", Categorie::query()->where("categorie_id")->count())
            ->description("Toutes nos catégories")
            ->color("success")
            ->chart([34,2,5,23])
            ->Icon("heroicon-o-rectangle-stack"),
            Stat::make("Sous_Categories ", Categorie::query()->whereNot("categorie_id")->count())
            ->description("les sous catégories associées aux catégories")
            ->color("warning")
            ->chart([34,2,5,23])
            ->Icon("heroicon-o-folder"),
            Stat::make("Expériences", Experience::query()->count())
            // ->description("Expérience en rapport avec le domaine étudié")
            ->description("les expériences pour les sous catégories")
            ->color("danger")
            ->chart([34,2,5,23])
            ->Icon("heroicon-o-briefcase"),
        ];
    }
}
