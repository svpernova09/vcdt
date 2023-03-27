<?php

namespace VCDT\Services;

use App\Models\Box;
use App\Models\Download;

class ProcessBoxes
{
    public function __invoke()
    {
        $boxes = Box::all();
        $stats = [];

        foreach ($boxes as $box) {
            $service = new FetchStatistics($box->username.'/'.$box->name);
            $stats[$box->id] = $service->getStats();

            Download::create([
                'box_id' => $box->id,
                'downloads' => $stats[$box->id]['downloads'] ?? 0,
            ]);
        }
    }
}
