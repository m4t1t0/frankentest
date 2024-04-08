<?php

declare(strict_types=1);

namespace Tests\Functional\Item;

use Codeception\Util\HttpCode;
use Tests\Support\FunctionalTester;
use Tests\Support\Helper\Domain\Item\ItemMother;

final class ShowItemCest
{
    public function seeItemDetails(FunctionalTester $I): void
    {
        $itemId = '4c0acdf1-b67c-42e4-94f8-cfaed9e7e950';

        $item = ItemMother::withUuid($itemId);
        $I->haveItem($item);

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/api/item/' . $itemId);
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'id' => $itemId,
        ]);
    }
}
