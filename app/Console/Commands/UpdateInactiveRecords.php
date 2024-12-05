<?php

namespace App\Console\Commands;

use App\Models\TuDo as ModelsTuDo;
use Illuminate\Console\Command;
use Carbon\Carbon;
use App\TuDo;

class UpdateInactiveRecords extends Command
{
    protected $signature = 'records:update';
    protected $description = 'Update inactive records';

    public function handle()
    {
        // Lấy thời điểm 3 tiếng trước
        $tenMinutesAgo = Carbon::now()->subMinutes(10);

        // Lấy tất cả các bản ghi có is_active = 1 và updated_at nhỏ hơn thời điểm 3 tiếng trước
        $inactiveRecords = ModelsTuDo::where('is_active', 1)
                                ->where('updated_at', '<', $tenMinutesAgo)
                                ->get();

        // Lặp qua từng bản ghi và cập nhật trường is_active thành 0
        foreach ($inactiveRecords as $record) {
            $record->is_active = 0;
            $record->save();
        }

        $this->info('Inactive records updated successfully.');
    }
}
