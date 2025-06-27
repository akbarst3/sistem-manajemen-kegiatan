<?php

namespace App\Filament\Resources\DaftarKegiatanResource\Pages;

use App\Filament\Resources\KegiatanResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
class CreateDaftarKegiatan extends CreateRecord
{
    protected static string $resource = KegiatanResource::class;
        protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['status'] = 'approved';
        $data['created_by'] = Auth::id();
        return $data;
    }
}
