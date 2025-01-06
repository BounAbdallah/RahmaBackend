@component('mail::message')
# Bonjour {{ $colis->user->name }},

Le statut de votre colis a été mis à jour.

@component('mail::panel', ['bgColor' => '#FF9F02', 'borderRadius' => '5px', 'padding' => '10px'])
### Nouveau statut : **{{ $statut }}**
@endcomponent

Vous pouvez voir les détails de votre colis en cliquant sur le lien ci-dessous.

@component('mail::button', ['url' => url('/colis/' . $colisId)])
Voir mon colis
@endcomponent

Merci pour votre confiance.

Cordialement,
**L'équipe de gestion des colis**
@endcomponent
