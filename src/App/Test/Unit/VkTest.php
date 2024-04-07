<?php

use PHPUnit\Framework\TestCase;

class VKTest extends TestCase
{
    // Создается объект класса VK с определенным accessToken, затем метод getToken() вызывается и 
    // проверяется совпадение ожидаемого значения accessToken с фактическим значением, возвращаемым методом getToken().

    public function testGetToken()
    {
        $accessToken = '1234567890';
        $vk = new \App\VK($accessToken);
        $this->assertSame($accessToken, $vk->getToken());
    }
    
    // testGetVersion() - Создается объект класса VK с определенной версией, затем метод getVersion() 
    // вызывается и проверяется совпадение ожидаемой версии с фактической версией, возвращаемой методом getVersion().
    
    public function testGetVersion()
    {
        $version = '5.130';
        $vk = new \App\VK(false, $version);
        $this->assertSame($version, $vk->getVersion());
    }
    
    // testSetToken() - Создается объект класса VK без передачи accessToken, затем методу setToken() передается новый accessToken, 
    // после чего проверяется совпадение ожидаемого значения accessToken с фактическим значением, возвращаемым методом getToken().

    public function testSetToken()
    {
        $accessToken = '0987654321';
        $vk = new \App\VK();
        $vk->setToken($accessToken);
        $this->assertSame($accessToken, $vk->getToken());
    }
    
    // testSetVersion() - Создается объект класса VK без передачи версии, затем методу setVersion() передается новая версия, 
    // после чего проверяется совпадение ожидаемой версии с фактической версией, возвращаемой методом getVersion()

    public function testSetVersion()
    {
        $version = '5.131';
        $vk = new \App\VK();
        $vk->setVersion($version);
        $this->assertSame($version, $vk->getVersion());
    }
}

?>