<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    public Order $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail']; // send email
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $order = $this->order;
        $customer = $order->customer;

        return (new MailMessage)
            ->subject('New Order Created: #' . $order->order_number)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('A new order has been created in ImpactGuru CRM.')
            ->line('Order #: ' . $order->order_number)
            ->line('Customer: ' . ($customer?->name ?? 'N/A'))
            ->line('Amount: ₹ ' . number_format($order->amount, 2))
            ->line('Status: ' . ucfirst($order->status))
            ->line('Date: ' . $order->order_date)
            ->action('View Orders', url(route('orders.index')))
            ->line('Thank you for using the CRM!');
    }
}
