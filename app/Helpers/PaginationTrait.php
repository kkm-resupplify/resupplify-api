<?php

namespace App\Helpers;

trait PaginationTrait
{
  public function paginate($data)
  {
    return [
      'pagination' => [
        'currentPage' => $data->currentPage(),
        'totalPages' => $data->lastPage(),
        'perPage' => $data->perPage(),
        'countRecords' => $data->count(),
        'totalRecords' => $data->total(),
      ]
    ];
  }
}
