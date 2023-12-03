<?php

namespace App\Http\Dto\Warehouse;

use App\Http\Dto\BasicDto;
use Spatie\LaravelData\Attributes\Validation\Max;


class WarehouseDto extends BasicDto
{
    #[Max(60)]
    public string $name;

    #[Max(300)]
    public string $description;
}
