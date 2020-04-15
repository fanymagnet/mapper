    class Root
    {
        public int      $integer;
        public string   $string;
        public bool     $boolean;
        public float    $float;
        public UserInfo $userInfo;
    }

    class UserInfo
    {
        public int     $id;
        public string  $username;
        public string  $password;
        public Profile $profile;
    }

    class Profile
    {
        public string $gender;
        public int    $age;
        public array  $limits;
        public object $params;
    }

    ...

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
    $object = $mapper->map(Root::class, $data);

    var_dump($object);

    ...

    object(Root)#120 (5) {
      ["integer"]=>int(13)
      ["string"]=>string(4) "test"
      ["boolean"]=>bool(true)
      ["float"]=>float(15.3)
      ["userInfo"]=>object(UserInfo)#122 (4) {
        ["id"]=>int(10)
        ["username"]=>string(4) "john"
        ["password"]=>string(6) "qwerty"
        ["profile"]=>object(Profile)#123 (4) {
          ["gender"]=>string(1) "m"
          ["age"]=>int(46)
          ["limits"]=>array(2) {
            [0]=>int(10)
            [1]=>int(40)
          }
          ["params"]=>object(stdClass)#124 (2) {
            ["lastIp"]=>string(8) "10.0.0.1"
            ["lastLogin"]=>string(10) "2020-12-12"
          }
        }
      }
    }