<?php

declare(strict_types=1);

namespace Portfolio\Contact;

use Portfolio\View;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

/**
 * Emails the contact form's messages over SMTP. They come from the site's own address, which passes SPF/DMARC;
 * replying goes to the visitor.
 */
final class ContactMailer
{
    public function __construct(
        private readonly string $dsn,
        private readonly string $from,
        private readonly string $to,
    ) {
    }

    /** @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface */
    public function send(ContactMessage $message): void
    {
        $name = View::e($message->name);
        $email = View::e($message->email);
        $body = nl2br(View::e($message->message));

        $mail = (new Email())
            ->from(new Address($this->from, 'Portfolio'))
            ->to($this->to)
            ->replyTo(new Address($message->email, $message->name))
            ->subject('New Contact Form Submission')
            ->text("Name: $message->name\nEmail: $message->email\n\n$message->message")
            ->html(<<<HTML
                <html>
                <body>
                    <div style="max-width: 600px; margin: 0 auto; padding: 1em; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9;">
                        <h2 style="color: #8E1616; margin-bottom: 1em; width: 100%; text-align: center;">New Contact Form Submission</h2>
                        <p style="margin: 0.5em 0;"><strong>Name:</strong> $name</p>
                        <p style="margin: 0.5em 0;"><strong>Email:</strong> $email</p>
                        <p style="margin: 0.5em 0;"><strong>Message:</strong></p>
                        <p style="background-color: #f0f0f0; padding: 1em; border-radius: 5px; margin-top: 1em;">$body</p>
                        <div style="margin-top: 2em; font-size: 0.9em; color: #666; text-align: center;">
                            <p>This email was sent via your website's contact form.</p>
                        </div>
                    </div>
                </body>
                </html>
                HTML);

        (new Mailer(Transport::fromDsn($this->dsn)))->send($mail);
    }
}
