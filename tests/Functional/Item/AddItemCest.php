<?php

declare(strict_types=1);

namespace Tests\Functional\Item;

use Codeception\Util\HttpCode;
use Tests\Support\FunctionalTester;

final class AddItemCest
{
    public function seeItemCreated(FunctionalTester $I): void
    {
        $itemId = 'c9d3de86-6c2e-42a1-9c87-86dcae10bfe5';
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/api/item', [
            'id' => $itemId,
	        'name' => 'Prueba 1',
	        'description' => 'Primera prueba',
            'quantity' => 5,
            'price' => 10.95
        ]);
        $I->seeResponseCodeIs(HttpCode::ACCEPTED);
    }
}
