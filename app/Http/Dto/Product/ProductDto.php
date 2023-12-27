<?php

namespace App\Http\Dto\Product;

use App\Http\Dto\BasicDto;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\MimeTypes;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class ProductDto extends BasicDto
{
    #[Max(90)]
    public string $producer;
    #[Max(90)]
    public string $code;
    public int $productUnitId;
    public int $productSubcategoryId;
    public array $translations;
    public ?array $productTagsId;
    public ?int $status;
    #[Nullable]
    #[Max(100)]
    public UploadedFile $image;
}
