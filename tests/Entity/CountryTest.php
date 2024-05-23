<?php

namespace App\Tests\Entity;

use App\Entity\Country;
use PHPUnit\Framework\TestCase;

class CountryTest extends TestCase
{
    public function testGetName() {
        $country = new Country();
        $country->setName('33T');
        $this->assertEquals('33T', $country->getName());
    }

    public function testSetName() {
        $country = new Country();
        $country->setName('33T');
        $this->assertEquals('33T', $country->getName());
        $country->setName('45T');
        $this->assertEquals('45T', $country->getName());
    }

    public function testGetId() {
        $country = new Country();
        $country->setId(1);
        $this->assertEquals(1, $country->getId());
    }
}