<?php

declare(strict_types=1);

namespace Portfolio\Contact;

/** A message from the contact form, checked */
final readonly class ContactMessage
{
    private const MAX_NAME = 100;
    private const MAX_MESSAGE = 5000;

    private function __construct(public string $name, public string $email, public string $message)
    {
    }

    /**
     * @param array<string, mixed> $post
     *
     * @throws InvalidMessage with the text to show the visitor
     */
    public static function fromPost(array $post): self
    {
        $field = static fn (string $name): string => is_string($post[$name] ?? null) ? trim($post[$name]) : '';

        // One line: it ends up in the email's headers
        $name = preg_replace('/[\r\n\t]+/', ' ', $field('name')) ?? '';
        $email = filter_var($field('email'), FILTER_VALIDATE_EMAIL) ?: '';
        $message = $field('message');

        if ($name === '' || $email === '' || $message === '') {
            throw new InvalidMessage('All fields are required.');
        }
        if (mb_strlen($name) > self::MAX_NAME || mb_strlen($message) > self::MAX_MESSAGE) {
            throw new InvalidMessage('Your message is too long.');
        }

        return new self($name, $email, $message);
    }
}
