<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    // Nous avons supprimé refreshTestDatabase ici pour éviter les conflits de signature.
    // Laravel utilisera la version native du trait RefreshDatabase.
}