<?php

declare(strict_types=1);

namespace App\Yahoo;

use App\Yahoo\Request\HistoricalDataRequest;
use App\Yahoo\Response\HistoricalDataResponse;

interface YahooClientInterface
{
    public function getHistoricalData(HistoricalDataRequest $request): HistoricalDataResponse;
}
