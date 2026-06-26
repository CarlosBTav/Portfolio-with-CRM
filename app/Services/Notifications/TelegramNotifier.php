<?php

namespace App\Services\Notifications;

use App\Models\Message;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

class TelegramNotifier
{
    /**
     * Aviso de un error de servidor (500) al bot personal. Mismo bot que los
     * mensajes de la web (es el bot del desarrollador). No lanza excepciones:
     * un fallo al avisar no debe romper el manejo del error original.
     */
    public function sendServerError(Throwable $e, ?string $method = null, ?string $url = null): void
    {
        $config = config('services.telegram');
        $botToken = (string) ($config['bot_token'] ?? '');
        $chatId = (string) ($config['chat_id'] ?? '');

        if ($botToken === '' || $chatId === '') {
            return;
        }

        $lines = ['🔥 <b>[portfolio-cms] Error 500 en la web</b>'];

        if ($method || $url) {
            $lines[] = '🔗 <code>'.$this->escape(trim(($method ? $method.' ' : '').($url ?? ''))).'</code>';
        }

        $lines[] = '💥 <b>'.$this->escape(class_basename($e)).'</b>';
        $lines[] = '🐞 <code>'.$this->escape(Str::limit($e->getMessage(), 300)).'</code>';
        $lines[] = '📄 <i>'.$this->escape(Str::after($e->getFile(), base_path().'/')).':'.$e->getLine().'</i>';

        try {
            Http::timeout(15)->post(
                sprintf('https://api.telegram.org/bot%s/sendMessage', $botToken),
                [
                    'chat_id' => $chatId,
                    'text' => implode("\n", $lines),
                    'parse_mode' => 'HTML',
                    'disable_web_page_preview' => true,
                ]
            );
        } catch (Throwable) {
            // Silencioso a propósito.
        }
    }

    public function sendNewMessageAlert(Message $message): void
    {
        $config = config('services.telegram');

        $botToken = (string) ($config['bot_token'] ?? '');
        $chatId = (string) ($config['chat_id'] ?? '');

        if ($botToken === '' || $chatId === '') {
            throw new RuntimeException('Telegram no está configurado.');
        }

        $endpoint = sprintf('https://api.telegram.org/bot%s/sendMessage', $botToken);

        $response = Http::post($endpoint, [
            'chat_id' => $chatId,
            'text' => $this->buildBody($message),
            'parse_mode' => 'HTML',
            'disable_web_page_preview' => true,
        ]);

        if (! $response->successful()) {
            throw new RuntimeException(
                'Error enviando Telegram: '.$response->status().' '.$response->body()
            );
        }
    }

    private function buildBody(Message $message): string
    {
        $unreadCount = Message::query()
            ->where('is_read', false)
            ->count();

        $panelUrl = rtrim((string) config('app.url'), '/').'/messages';

        $senderName = $this->escape((string) $message->sender_name);
        $senderEmail = $this->escape((string) $message->sender_email);
        $content = $this->escape((string) $message->content);
        $createdAt = $this->escape(
            $message->created_at?->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i')
        );

        return implode("\n", [
            '🔔 <b>Nuevo mensaje desde tu web</b>',
            '',
            '👤 <b>Contacto:</b> '.$senderName,
            '📧 <b>Email:</b> '.$senderEmail,
            '🕒 <b>Fecha:</b> '.$createdAt,
            '',
            '💬 <b>Mensaje:</b>',
            '<blockquote>'.$content.'</blockquote>',
            '',
            '📌 <b>Recordatorio:</b> tienes <b>'.$unreadCount.'</b> mensaje(s) sin leer.',
            '➡️ <a href="'.$panelUrl.'">Abrir panel de mensajes</a>',
        ]);
    }

    private function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
