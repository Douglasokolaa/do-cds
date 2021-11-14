<?php

namespace App\Imports;

use App\Enums\GMBStatus;
use App\Enums\ProjectType;
use App\Models\GmbSubmission;
use App\Models\Project;
use App\Models\Roles\Admin;
use App\Models\User;
use App\Notifications\ImportSuccessNotification;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\AfterImport;

class GMBSubmissionImport implements ToModel, WithUpserts, WithEvents, WithBatchInserts, WithChunkReading, WithValidation, ShouldQueue
{
    /**
     * @param  array  $row
     *
     * @return Model|null
     */
    public function model(array $row)
    {
        $user = User::whereEmail($row['corper_email'])->orWhereHas('profile', function ($query) use ($row) {
            $query->where('nysc_state_code', $row['corper_email'])->orWhere('phone_number', $row['corper_phone_number']);
        })->firstOrFail(['id']);

        $status = GMBStatus::fromValue((int ) $row['status']);
        return new GmbSubmission([
            'business_name' => $row['business_name'],
            'business_owner' => $row['business_owner'],
            'business_email' => $row['business_email'],
            'owner_gender' => $row['owner_gender'],
            'status' => $status,
            'project_id' => Project::whereType(ProjectType::gmb)->first()->id,
            'approved_by' => Admin::first()->id,
            'user_id' => $user->id,
            'reject_reason' => $row['reject_reason']
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 5000;
    }

    public function registerEvents(): array
    {
        return [
            AfterImport::class => function (AfterImport $event) {
                Admin::notifyAll(new ImportSuccessNotification($event, 'Business'));
            },
        ];
    }

    public function uniqueBy(): string
    {
        return 'business_name';
    }

    public function rules(): array
    {
        return [
            'business_name' => ['required', 'string', 'min:3', 'unique:gmb_submissions'],
            'business_owner' => ['required', 'string', 'min:3'],
            'business_email' => ['required', 'email:dns'],
            'owner_gender' => ['required', 'string', 'in:,male,female'],
            'status' => ['required', new EnumValue(GMBStatus::class)],
        ];
    }
}
