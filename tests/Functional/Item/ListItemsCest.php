<?php

declare(strict_types=1);

namespace Functional\Item;

use Codeception\Util\HttpCode;
use Tests\Support\FunctionalTester;
use Tests\Support\Helper\Domain\Item\ItemMother;

final class ListItemsCest
{
    public function seeItemDetails(FunctionalTester $I): void
    {
        $itemIds = [
            'b0792726-6335-4759-a56c-ede3b9d268d0',
            'c371f5b5-21bd-4a10-9e37-ae454b2e2e7e',
            'fbd3b511-8122-4760-87d8-9d0428df65e3',
        ];

        foreach ($itemIds as $itemId) {
            $item = ItemMother::withUuid($itemId);
            $I->haveItem($item);
        }

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/api/items');
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            [
                'id' => $itemIds[0],
            ],
            [
                'id' => $itemIds[1],
            ],
            [
                'id' => $itemIds[2],
            ],
        ]);
    }
}
