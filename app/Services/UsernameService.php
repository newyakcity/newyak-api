<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2019-03-11
 * Time: 11:01
 */

namespace App\Services;


class UsernameService
{
    static function generateUsername($uuid): string {
        $adjectives = config('adjectives.values');
        $nouns = config('nouns.values');

        $adjective = rand(0, count($adjectives));

        $noun = rand(0, count($nouns));

        return $adjectives[$adjective] . $nouns[$noun] . substr($uuid, 0, 5);
    }
}