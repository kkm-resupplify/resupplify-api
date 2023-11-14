<?php

namespace App\Http\Dto\Company;

use App\Http\Dto\BasicDto;
use App\Models\Company\Enums\CompanyStatusEnum;
use Spatie\LaravelData\Attributes\Validation\In;

class CompanyMassStatusUpdateDto extends BasicDto
{

    public function __construct(
        public array $companyIds,
        #[In([0, 1, 2, 3, 4, 5])]
        public int $newStatus
    ) {
    }
}
