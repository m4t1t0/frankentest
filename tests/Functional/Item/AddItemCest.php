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
        $eventType = 'app.item.core.aggregate.item.events.v1.item_was_added';
        $payload = [
            'id' => $itemId,
            'name' => 'Prueba 1',
            'description' => 'Primera prueba',
            'quantity' => 5,
            'price' => 10.95
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/api/item', $payload);

        $I->seeResponseCodeIs(HttpCode::ACCEPTED);
        $I->seeEventExists($itemId, $eventType);
        $I->seeInReadDatabase('all_items', $itemId);
    }
}
