<?php

declare(strict_types=1);

namespace Portfolio;

use DateTimeImmutable;

final class Person
{
    /** Full years between the birthdate (Y-m-d) and the given day */
    public static function ageOn(string $birthdate, DateTimeImmutable $today): int
    {
        return (new DateTimeImmutable($birthdate))->diff($today)->y;
    }
}
