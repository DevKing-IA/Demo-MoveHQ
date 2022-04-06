<?php

namespace MovehqAppTests;

use MovehqAppTests\Traits\CreatesModels;
use MovehqAppTests\Traits\DBSetup;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use CreatesModels;
    use DBSetup;
}
