<?php

declare(strict_types=1);

namespace Portfolio\Contact;

use InvalidArgumentException;

/** A contact form message that can't be sent; its message is shown to the visitor */
final class InvalidMessage extends InvalidArgumentException
{
}
