<?php

namespace App\Supports\DTO;

use App\Enums\SupportStatus;
use App\Http\Requests\StoreUpdateRequest;

class UpdateSupportDTO
{
    public function __construct(
        public string $id,
        public string $subject,
        public SupportStatus $status,
        public string $body
    ) {
    }

    public static function makeFromRequest(StoreUpdateRequest $request): self
    {
        return new self(
            $request->id,
            $request->subject,
            SupportStatus::A,
            $request->body
        );
    }
}
