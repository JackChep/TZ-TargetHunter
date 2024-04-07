<?php

use PHPUnit\Framework\TestCase;
use MongoDB\Client;
use MongoDB\Collection;

class MongoTest extends TestCase
{
    public function testInsertMany()
    {
        // Создаем заглушки (mocks) для MongoDB\Client и MongoDB\Collection
        $mongodbClientMock = $this->createMock(Client::class);
        $mongo = new \App\Mongo('mongodb://localhost:27017');
        $mongo->connect = $mongodbClientMock;

        $data = [
            ['name' => 'Евгений'],
            ['name' => 'Ярослав'],
            ['name' => 'Дмитрий']
        ];

        $collectionMock = $this->createMock(Collection::class);
        $collectionMock->expects($this->once())
            ->method('insertMany')
            ->with($data);

        $mongodbClientMock->expects($this->once())
            ->method('__get') // Метод доступа к свойству
            ->with('newdb')
            ->willReturn((object)['users' => $collectionMock]);

        $mongo->insertMany($data);
    }
}

?>