@component('mail::message')
# <span style="color: #074C72;">Bonjour {{ $reservation->user->name }},</span>

Nous souhaitons vous informer que le statut de votre réservation a été mis à jour avec succès.

@component('mail::panel', ['bgColor' => '#FF9F02', 'borderRadius' => '5px', 'padding' => '10px'])
### <span style="color: #c60f0f;">Nouveau statut : <strong>{{ $statut }}</strong></span>
@endcomponent

Nous restons à votre disposition pour toute question supplémentaire.

@component('mail::button', ['url' => 'https://votre-site.com/reservations/'.$reservation->id, 'style' => 'background-color: #074C72; color: white; border-radius: 5px; padding: 10px 20px; font-weight: bold; text-transform: uppercase;'])
Voir votre réservation
@endcomponent

Merci pour votre confiance et à très bientôt !

Cordialement,
**L'équipe de réservation**

---

### Détails de la réservation

- **Réservation ID** : {{ $reservation->id }}
- **Date de réservation** : {{ $reservation->created_at }}
- **Statut actuel** : <span style="color: #c60f0f; font-weight: bold;">{{ $statut }}</span>

Merci de nous avoir choisis !

@endcomponent
