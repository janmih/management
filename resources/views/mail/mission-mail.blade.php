@component('mail::message')
    # Convocation pour une mission

    Cher/Chère {{ $fullName }},

    Nous avons le plaisir de vous convier à une mission qui se tiendra du {{ $date_debut }} au {{ $date_fin }}.

    **Lieu de la mission :** {{ $lieu }}

    **Observations :**
    {{ $observations }}

    Nous comptons sur votre présence active et votre contribution pour le succès de cette mission.

    N'oublier pas notre cotisation sociale de 10.000 Ariary.

    Cordialement,
    {{ config('app.name') }}
@endcomponent
