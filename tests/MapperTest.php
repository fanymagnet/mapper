<?php

namespace fanymagnet\mapper\tests;

use fanymagnet\mapper\tests\entries\UserInfo;
use fanymagnet\mapper\tests\entries\Profile;
use fanymagnet\mapper\tests\entries\Root;
use PHPUnit\Framework\TestCase;
use fanymagnet\mapper\Mapper;

/**
 * Class MapperTest
 * @package fanymagnet\mapper\tests
 */
class MapperTest extends TestCase
{
    public function testMap(): void
    {
        $data = [
            'notFound' => 45567,
            'integer'  => 13,
            'string'   => 'test',
            'boolean'  => true,
            'float'    => 15.3,
            'userInfo' => [
                'id'       => 10,
                'username' => 'john',
                'password' => 'qwerty',
                'profile'  => [
                    'gender' => 'm',
                    'age'    => 46,
                    'limits' => [10, 40],
                    'params' => [
                        'lastIp'    => '10.0.0.1',
                        'lastLogin' => '2020-12-12'
                    ]
                ]
            ]
        ];

        $map = [
            'userInfo' => UserInfo::class,
            'profile'  => Profile::class
        ];

        $mapper = new Mapper($map);

        /* @var Root $object */
        $object = $mapper->map(Root::class, $data);

        $this->assertSame($object->userInfo->profile->params->lastIp, '10.0.0.1');
    }
}
